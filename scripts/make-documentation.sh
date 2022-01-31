#!/bin/bash

set -e

REPOSITORY_ROOT="$(dirname $0)/../"
BUILD_ROOT="$(realpath ${REPOSITORY_ROOT}/build)"

function downloadRelease() {
    rm -f "${BUILD_ROOT}/doctum.phar"
    curl -# -o "${BUILD_ROOT}/doctum.phar" -O https://doctum.long-term.support/releases/5/doctum.phar
    chmod +x "${BUILD_ROOT}/doctum.phar"
}

function checkRelease() {
    if [ -f "${BUILD_ROOT}/doctum.phar" ]; then
        curl -s -o "${BUILD_ROOT}/doctum.phar.sha256" -O https://doctum.long-term.support/releases/5/doctum.phar.sha256
        cd "${BUILD_ROOT}/"
        set +e
        sha256sum --check --strict doctum.phar.sha256 1> /dev/null 2> /dev/null
        MATCHES_HASH=$?
        set -e
        cd - > /dev/null
        if [ ${MATCHES_HASH} -gt 0 ]; then
            downloadRelease
        else
            echo 'You are using the latest 5.x.x release of Doctum.'
        fi
    else
        downloadRelease
    fi
}

function buildDocumentation() {
    "${BUILD_ROOT}/doctum.phar" update --ignore-parse-errors -vvv --force "${REPOSITORY_ROOT}/scripts/doctum.php"
    find "${REPOSITORY_ROOT}doc" -type f -name ".delete-me" -delete
    rm "${REPOSITORY_ROOT}doc/renderer.index"
    rm "${REPOSITORY_ROOT}doc/PROJECT_VERSION"
    rm "${REPOSITORY_ROOT}doc/DOCTUM_VERSION"
}

echo "Using build root: ${BUILD_ROOT}"

if [ ! -d ${BUILD_ROOT} ]; then
    mkdir ${BUILD_ROOT}
fi

checkRelease

buildDocumentation