#!/usr/bin/env sh

if [ -z "${USER_ID}" ]; then
    echo "USER_ID not set. Using default UID."
else
    echo "Setting UID to ${USER_ID}"
    # Modify the UID of the node user
    usermod -u ${USER_ID} node
fi

echo "Running command: npm run $@"

exec npm run "$@"

