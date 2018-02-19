pipeline {
    agent any

    stages {
        stage('Build') { 
            steps { 
                echo 'build docker image'
                sh "conposer install"
                sh "docker build -t gcpedia:jenkinstest ."
            }
        }
        stage('Test'){
            steps {
                echo 'run automated tests'
            }
        }
    }
}
