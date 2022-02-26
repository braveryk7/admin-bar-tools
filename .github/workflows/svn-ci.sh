#!bin/sh

# arsg...
# 1. version
# 2. SVN username
# 3. SVN password

if [ $# != 4 ]; then
	echo "Require 4 arguments."
	exit 1
fi

# svn info --username "${2}" "${4}"

svn ci -m 'version "${1}" release' --username ${2} --password ${3} --non-interactive 

# svn ci -m "version ${1} release" --no-auth-cache --password "${3}"
# svn up
