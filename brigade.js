const { events, Job } = require("brigadier");

events.on("push", function(e, project) {
  console.log("received push for commit " + e.revision.commit)
  
  var build = new Job("build", "docker:dind")
  build.privileged = true;
  build.env.COMMIT = e.revision.commit
  build.env.DOCKER_USER = project.secrets.dockerUsr
  build.env.DOCKER_PASS = project.secrets.dockerPass
  build.tasks = [
    "dockerd-entrypoint.sh &", // Start the docker daemon
    "sleep 20", // Grant it enough time to be up and running
    "cd gccpedia/",
    "docker build -t phanoix/gcpedia:$COMMIT .",
    "docker login -u $DOCKER_USER -p $DOCKER_PASS",
    "docker push phanoix/gcpedia:$COMMIT"
  ]
  
  // TODO: update, push, apply k8s manifest with new tag
  
  var notify Job("notify", "alpine:3.4")
  hello.env.CHATKEY = project.secrets.chatKey
  hello.tasks = [
    "echo Hello",
    "echo World",
    "apk update",
    "apk add curl",
    "curl -X POST -H 'Content-Type: application/json' --data '{\"username\":\"Brigade\",\"icon_emoji\":\":k8s:\",\"text\":\"Brigade wiki imaged finished.\",\"attachments\":[{\"title\":\"Brigade build finished!\",\"title_link\": \"https://hub.docker.com/r/phanoix/gcconnex/tags/\",\"text\": \"New wiki available at Docker hub.\",\"color\":\"#764FA5\"}]}' https://message.gccollab.ca/hooks/$CHATKEY"      //test rocket chat notification
  ]
  
  build.run().then(() => { notify.run() })
})
