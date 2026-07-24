docker exec wrench-ppm-mysql mysql --host=127.0.0.1 --user=wrenchppm --password=wrenchppm123 wrenchppmdb `
  -e "select username, application, session, total_seconds, created_at, updated_at from wtb_publisher_minutes order by updated_at desc; select username, stream, elapsed_seconds, created_at from wtb_disconnects order by created_at desc;"
