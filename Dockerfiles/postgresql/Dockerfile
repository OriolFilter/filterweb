FROM postgres:13-alpine

LABEL version='1'
LABEL description="Customized Dockerfile for Postgresql-Alpine 13 (it just adds a script)"
LABEL org.opencontainers.image.authors='filter.oriol@gmail.com'

ADD sources /sources
WORKDIR /sources
RUN ln -s $(pwd)/build.sh /docker-entrypoint-initdb.d/init_01.sh