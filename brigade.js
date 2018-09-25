const { events, Job } = require("brigadier");

events.on("push", function(e, project) {
  console.log("received push for commit " + e.revision.commit)
  
  // build the new container and tag with git commit hash
  var build = new Job("build", "docker:dind")
  build.privileged = true;
  build.env.COMMIT = e.revision.commit
  build.env.DOCKER_USER = project.secrets.dockerUsr
  build.env.DOCKER_PASS = project.secrets.dockerPass
  build.tasks = [
    "dockerd-entrypoint.sh &", // Start the docker daemon
    "sleep 20", // Grant it enough time to be up and running
    "cd /src/",
    "docker build -t phanoix/gcpedia:$COMMIT .",
    "docker login -u $DOCKER_USER -p $DOCKER_PASS",
    "docker push phanoix/gcpedia:$COMMIT"
  ]
  
  // update deployment with new tag
  var update = new Job("update", "lachlanevenson/k8s-kubectl:v1.10.5")
  update.env.TAG = e.revision.commit
  update.tasks = [
    "kubectl patch -n dev deploy wiki-deployment -p '{\"spec\":{\"template\":{\"spec\":{\"containers\":[{\"name\":\"wiki\",\"image\":\"phanoix/gcpedia:'$TAG'\"}]}}}}'"
  ]
  
  // notify via Rocket.Chat webhook
  var notify = new Job("notify", "alpine:3.4")
  notify.env.CHATKEY = project.secrets.chatKey
  notify.tasks = [
    "apk update",
    "apk add curl",
    "curl -X POST -H 'Content-Type: application/json' --data '{\"username\":\"Brigade\",\"icon_emoji\":\":k8s:\",\"text\":\"Wiki image built, dev updating.\",\"attachments\":[{\"title\":\"Brigade script finished!\",\"title_link\": \"https://hub.docker.com/r/phanoix/gcpedia/tags/\",\"text\": \"The new wiki image is available at Docker hub.\",\"color\":\"#764FA5\"}]}' https://message.gccollab.ca/hooks/$CHATKEY"      //test rocket chat notification
  ]
  
  build.run().then(() => { update.run().then(() => { notify.run() }) })
})
