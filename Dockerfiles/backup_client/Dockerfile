FROM postgres:13-alpine
LABEL version='1'
LABEL description="Customized Dockerfile for backup-ftpcli-Alpine 13"
LABEL org.opencontainers.image.authors='filter.oriol@gmail.com'
LABEL packages_installed="rsync tar openssh keychain"

ARG A_SFTPPORT=22
ARG A_ORIGINFOLDER=/master
ARG A_HOLDERFOLDER=/holder
ARG A_DESTINATIONFOLDER=/slave
ARG A_PREFIX=backup_

ENV SFTPUSER ''
ENV SFTPHOST ''
ENV SFTPDIR ''
ENV SFTPDIR ''

ENV SFTPPORT $A_SFTPPORT
ENV ORIGINFOLDER $A_ORIGINFOLDER
ENV HOLDERFOLDER $A_HOLDERFOLDER
ENV DESTINATIONFOLDER $A_DESTINATIONFOLDER
ENV PREFIX $A_PREFIX

RUN apk add --no-cache openssh rsync keychain tar
RUN mkdir $ORIGINFOLDER $HOLDERFOLDER $DESTINATIONFOLDER

RUN printf "/usr/bin/keychain --clear $HOME/.ssh/id_rsa \n   source $HOME/.keychain/$HOSTNAME-sh \n" > $HOME/.bashrc
# Adds .bashrc to our user, which enables us to connect using generated keys to avoid passwords

ADD scripts /scripts
WORKDIR /scripts

ENTRYPOINT bash /scripts/main.sh