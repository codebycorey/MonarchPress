#!/bin/sh

docker-machine create --driver virtualbox wordpress
eval "$(docker-machine env wordpress)"

docker build -t ewichern/wordpress dockerfile/
docker-compose up


# Notes:
### For lists of things:
# Containers - "docker ps"
# Images - "docker images"
# Machines - "docker-machine ls"

### To stop/remove things:
# To stop containers, either Ctrl+C in the terminal where they're running
# or type "docker stop containerName"

# To remove images, type "docker rmi imageName" -- can also use the hash 
# in place of the name. Might need the -f flag if there are containers still
# running, or of course you could go shut down the containers manually.

# To remove a docker machine, type "docker-machine kill machineName" and then
# "docker-machine rm machineName" 

### Updating!
# All that said, the script *should* be fine if you re-run it a second time
#
# Docker machine will just tell you that there's already a machine with that
# name.
#
# Then as long as the containers are 'stopped', the Dockerfile will update 
# the image to the latest versions of wordpress and wp-cli.
