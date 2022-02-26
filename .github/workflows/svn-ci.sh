#!bin/sh

# arsg...
# 1. version
# 2. SVN username
# 3. SVN password

if [ $# != 3]; then
	echo "Require 3 arguments."
	exit 1
fi

svn ci -m "version ${1} release" --non-interactive --no-auth-cache --username ${2} --password ${3} && svn up
