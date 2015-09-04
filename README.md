# README #

This README would normally document whatever steps are necessary to get your application up and running.

## Docker ##

First you need to have the Docker-toolbox for your platform from here: https://www.docker.com/toolbox
OR if you are using OSX and homebrew, you can type `brew cask install docker-toolbox` in a terminal.

Once that's done, create a docker-machine for the wordpress container to run on.
`docker-machine create --driver virtualbox wordpress` should do the trick. The last argument is going to be the name of your docker daemon.

Next run the command: `eval "$(docker-machine env wordpress)"` <-- change "wordpress" to whatever you named your machine. This will add environment variables for your docker daemon and remove the need to type them in every time you type a docker command.

Also probably want to type/run: `docker-machine ip wordpress` quickly and make note of the ip address returned -- this is what we'll type into the browser to see our wordpress site. You can add a custom entry to your /etc/hosts if you want, but it's not necessary.

And finally, type in `docker-compose up`. The first run will probably require downloading the wordpress and mariadb images from the docker hub registry, and then some text will scroll by. When it stops, and you see some messages that start `wordpress_1:` -- then your wordpress site should be up and ready to start poking around in. Changes should get saved locally to subdirectory `./src/`


### What is this repository for? ###

* Quick summary
* Version
* [Learn Markdown](https://bitbucket.org/tutorials/markdowndemo)

### How do I get set up? ###

* Summary of set up
* Configuration
* Dependencies
* Database configuration
* How to run tests
* Deployment instructions

### Contribution guidelines ###

* Writing tests
* Code review
* Other guidelines

### Who do I talk to? ###

* Repo owner or admin
* Other community or team contact
