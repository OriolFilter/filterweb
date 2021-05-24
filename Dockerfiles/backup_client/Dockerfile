FROM postgres:13-alpine

LABEL version='1'
LABEL description="Customized Dockerfile for rsync-ftpcli-Alpine 13"
LABEL org.opencontainers.image.authors='filter.oriol@gmail.com'
LABEL packages_installed="rsync sftp"

RUN apk add --no-cache openssh rsync keychain
#RUN apk add --no-cache lftp rsync

RUN printf "/usr/bin/keychain --clear $HOME/.ssh/id_rsa \n   source $HOME/.keychain/$HOSTNAME-sh \n" > $HOME/.bashrc

ADD scripts /scripts
WORKDIR /scripts

ENTRYPOINT bash /scripts/main.sh

