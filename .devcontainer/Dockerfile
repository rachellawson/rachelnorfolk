# [Choice] PHP version (use -bullseye variants on local arm64/Apple Silicon): 8, 8.1, 8.0, 7, 7.4, 7.3, 8-bullseye, 8.1-bullseye, 8.0-bullseye, 7-bullseye, 7.4-bullseye, 7.3-bullseye, 8-buster, 8.1-buster, 8.0-buster, 7-buster, 7.4-buster
ARG VARIANT=8-bullseye
FROM mcr.microsoft.com/vscode/devcontainers/php:0-${VARIANT}


USER root

RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
    && /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)" \
    && echo 'eval "$(/home/linuxbrew/.linuxbrew/bin/brew shellenv)"' >> /home/codespace/.profile \
    && eval "$(/home/linuxbrew/.linuxbrew/bin/brew shellenv)"
    

USER codespace

RUN brew install drud/ddev/ddev \
    && ddev config global --web-environment-add="PLATFORMSH_CLI_TOKEN=$PLATFORM"
    
