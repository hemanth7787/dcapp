#  Do this first -- >  sudo apt-get install fabric
#  keep the filename as "fabfile.py"
#  fab dev deploy -> runs dev method first then deploy
from __future__ import with_statement
from fabric.api import *
from fabric.colors import *
# from fabric.contrib import project
# from fabric.operations import put
import os

# globals
env.use_ssh_config = True
env.local_shell = "/bin/bash"

print(yellow("""

                       ^
                      / \\
                     /___\\
                    |=   =|
                    |     |
                    |  I  |
                    |     |
                    |  S  |
                    |     |
                    |  R  |
                    |     |
                    |  O  |
                    |     |
                   /|==!==|\\
                  / |==!==| \\
                 /  |==!==|  \\
                |  / ^ | ^ \  |
                | /  ( | )  \ |
                |/   ( | )   \|
                    ((   ))
                   ((  :  ))
                   ((  :  ))
                    ((   ))
                     (( ))
                      ( )
                       .
                       .

Launching ...
""", bold=True))

@task()
def dev():
    # Deploy to Codestager ,  "cl2" is from my ssh config
    env.hosts = ['cl2']

@task()
def publish():
    command = "git push"
    local('bash -l -c "%s"' % command)
    # Remote code directory
    code_dir = "/srv/www/dcapp_api/dc-app"
    with cd(code_dir):
        #run("umask 002 && git pull")
        run("git pull")
        print(green("""Code published :)""", bold=True))

@task()
def migrate():
    code_dir = "/srv/www/dcapp_api/dc-app"
    with cd(code_dir):
        run("umask 002 && php artisan migrate")
        print(green("""Database migrated :)""", bold=True))

@task()
def stash():
    code_dir = "/srv/www/dcapp_api/dc-app"
    with cd(code_dir):
        run("git  stash")
        print(green("""Remote changes destroyed ;)""", bold=True))