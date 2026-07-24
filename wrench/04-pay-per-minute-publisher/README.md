## Pay-per-minute publisher tracking

This example configures Wrench to authenticate an RTMP publisher with a database token and capture the number of seconds that publisher stays connected. The PPM monitor writes runtime into MySQL through `wrench.ppm.update.sql`.

### What it contains

- `docker-compose.yaml`: starts a MySQL database on port `3306`
- `dbinit/setup.sql`: creates the `wrenchppmdb` schema, a publisher token, and PPM tables
- `wowza/Application.xml`: preconfigured for a Wowza application named `ppm`
- `scripts/publish-test.ps1`: Windows helper that publishes a synthetic FFmpeg test stream
- `scripts/check-ppm.ps1`: Windows helper that shows the PPM and disconnect rows

### Run the database

```bash
docker compose up -d
```

The seeded publisher token is:

```text
publishsecret
```

### Configure Wowza

Install Wrench and the MySQL JDBC driver in Wowza's `lib` folder, then copy the example configuration into the existing `ppm` application:

```bash
mkdir -p /usr/local/WowzaStreamingEngine/conf/ppm
cp wowza/Application.xml /usr/local/WowzaStreamingEngine/conf/ppm/Application.xml
```

Restart the Wowza Streaming Engine after changing the application configuration.

### Publish a test stream

```bash
ffmpeg \
  -hide_banner \
  -re \
  -f lavfi -i "testsrc=size=1280x720:rate=30" \
  -f lavfi -i "sine=frequency=1000:sample_rate=44100" \
  -t 25 \
  -c:v libx264 -preset veryfast -pix_fmt yuv420p -g 60 -b:v 1800k \
  -c:a aac -b:a 128k \
  -rtmp_app "ppm?t=publishsecret" \
  -rtmp_playpath "publisher-test" \
  -f flv rtmp://127.0.0.1:1935/ppm
```

The script publishes to:

```text
rtmp://127.0.0.1:1935/ppm
```

For FFmpeg, the token is passed on the RTMP application field as `ppm?t=publishsecret` and the stream name is passed as the RTMP playpath. This keeps the token in Wowza's connection query string, where Wrench reads it.

### Example use cases

- Charge publishers by airtime, for example when creators buy broadcasting minutes before going live.
- Track how long each external encoder account is publishing for billing, reporting, or quota enforcement.
- Measure live event production time per customer, application, or publishing session.
- Reconcile encoder activity with platform-side stream records after a publisher disconnects.
- Build dashboards that show active publisher sessions and accumulated published seconds.

### Verify PPM tracking

Wait at least one monitor period after publishing starts, then run:

```bash
docker exec wrench-ppm-mysql mysql \
  --host=127.0.0.1 \
  --user=wrenchppm \
  --password=wrenchppm123 \
  wrenchppmdb \
  --execute="select username, application, session, total_seconds, created_at, updated_at from wtb_publisher_minutes order by updated_at desc; select username, stream, elapsed_seconds, created_at from wtb_disconnects order by created_at desc;"
```

Expected result: `wtb_publisher_minutes.total_seconds` increases while FFmpeg is publishing. After FFmpeg exits, `wtb_disconnects.elapsed_seconds` records the final RTMP session duration.
