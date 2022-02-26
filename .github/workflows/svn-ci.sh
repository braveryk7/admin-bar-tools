#!bin/sh

# arsg...
# 1. version
# 2. SVN username
# 3. SVN password

if [ $# != 3 ]; then
	echo "Require 3 arguments."
	exit 1
fi

svn info --username "${2}"

svn ci -m "version ${1} release" --non-interactive --no-auth-cache --password "${3}" && svn up
