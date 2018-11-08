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
    "docker push phanoix/gcpedia:$COMMIT",
    "docker logout"
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
  
  if ( e.revision.ref.indexOf('master') > -1 )  // test limiting to master branch
    build.run().then(() => { update.run().then(() => { notify.run() }) })
})


events.on("pull_request", function(e, project) {
  console.log("received push for commit " + e.revision.commit)
  
  pending = ghNotify("pending", `Build started for PR ${ JSON.parse(e.payload).number }`, e, project)
  
  // build the new container and tag with git commit hash
  var build = new Job("build", "docker:dind")
  build.privileged = true;
  build.env.TAG = `pr-${ JSON.parse(e.payload).number }-${ e.revision.commit }`
  build.env.BRANCH = `${ JSON.parse(e.payload).pull_request.head.ref }`
  build.env.DOCKER_USER = project.secrets.dockerUsr
  build.env.DOCKER_PASS = project.secrets.dockerPass
  build.tasks = [
    "dockerd-entrypoint.sh &", // Start the docker daemon
    "sleep 20", // Grant it enough time to be up and running
    "apk add git",
    "git clone https://github.com/gctools-outilsgc/gcpedia.git",
    "cd gcpedia/",
    "git checkout master",
    "git config user.email 'you@example.com' && git config user.name 'Your Name'",
    "git merge --no-ff origin/$BRANCH",
    "docker build -t phanoix/gcpedia:$TAG .",
    "docker login -u $DOCKER_USER -p $DOCKER_PASS",
    "docker push phanoix/gcpedia:$TAG",
    "docker logout"
  ]
  
  // update deployment with new tag
  var update = new Job("update", "lachlanevenson/k8s-kubectl:v1.10.5")
  update.env.TAG = `pr-${ JSON.parse(e.payload).number }-${ e.revision.commit }`
  update.tasks = [
    "kubectl patch -n dev deploy wiki-deployment -p '{\"spec\":{\"template\":{\"spec\":{\"containers\":[{\"name\":\"wiki\",\"image\":\"phanoix/gcpedia:'$TAG'\"}]}}}}'"
  ]
  
  // notify via Rocket.Chat webhook
  var notify = new Job("notify", "alpine:3.4")
  notify.env.CHATKEY = project.secrets.chatKey
  notify.env.PRNUM = `${ JSON.parse(e.payload).number }`
  notify.tasks = [
    "apk update",
    "apk add curl",
    "curl -X POST -H 'Content-Type: application/json' --data '{\"username\":\"Brigade- PR\",\"icon_emoji\":\":doge:\",\"text\":\"Brigade build finished!\",\"attachments\":[{\"title\":\"PR '$PRNUM' ready for testing.\",\"title_link\": \"https://github.com/gctools-outilsgc/gcpedia/pull/'$PRNUM'\",\"text\": \"The merged image is also available at Docker hub.\",\"color\":\"#764FA5\"}]}' https://message.gccollab.ca/hooks/$CHATKEY"      //test rocket chat notification
  ]
  
  pending.run()
  build.run().then(() => { update.run().then(() => { notify.run().then(() => { 
    return ghNotify("success", `Build for PR ${ JSON.parse(e.payload).number } succeded, test image ready`, e, project).run() }) }) })
})


function ghNotify(state, msg, e, project) {
  const gh = new Job(`notify-${ state }`, "technosophos/github-notify:latest")
  gh.env = {
    GH_REPO: project.repo.name,
    GH_STATE: state,
    GH_DESCRIPTION: msg,
    GH_CONTEXT: "brigade",
    GH_TOKEN: project.secrets.ghToken,
    GH_COMMIT: e.revision.commit,
    GH_TARGET_URL: `https://hub.docker.com/r/phanoix/gcpedia/tags`,
  }
  return gh
}
