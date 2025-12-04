FROM nginx:latest

COPY ./default.conf /etc/nginx/conf.d/default.conf
COPY ./nginx.conf /etc/nginx/nginx.conf

ARG APP_NAME
ARG FPM_PORT
WORKDIR /etc/nginx/conf.d
RUN sed -i "s/@APP_NAME@/$APP_NAME/" default.conf
RUN sed -i "s/@FPM_PORT@/$FPM_PORT/" default.conf

EXPOSE 80 81
