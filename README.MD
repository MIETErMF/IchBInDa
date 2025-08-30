### service containers:
```bash
docker compose -f docker-compose.services.yml -p ichbinda-services up -d
```

### php and caddy containers:
```bash
docker compose up -d --build
```
