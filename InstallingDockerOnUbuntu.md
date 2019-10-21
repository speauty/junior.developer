#### Installing Docker on Ubuntu 18.04

*Installing too easy, just some simple cmd, so don't be scared*

1.  Upgrading: `sudo apt-get upgrade`;
2.  Downloading: `sudo apt-get install docker`;
3.  Installing: `sudo apt install docker.io`;
4.  Checking version: `docker --version`, it will show `Docker version 18.09.7, build 2d0083d`;

So, it's ok. But running broken, warning `docker: Got permission denied while trying to connect to the Docker daemon socket at unix:///var/run/docker.sock: Post http://%2Fvar%2Frun%2Fdocker.sock/v1.39/containers/create: dial unix /var/run/docker.sock: connect: permission denied. See 'docker run --help'.`, you can add your account to docker group.
