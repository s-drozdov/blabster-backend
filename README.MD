### Local build in docker

```sh
docker compose build --build-arg PUID="$(id -u)" --build-arg PGID="$(id -g)"
```
