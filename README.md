# Hooked on a Needle - WordPress Development Environment

A containerized WordPress development environment using Docker Compose, designed for local theme and plugin development with seamless CI/CD integration.

## Prerequisites

Before you begin, ensure you have the following installed:

- **Docker Desktop** (includes Docker Engine and Docker Compose)
  - [Install Docker Desktop for Mac](https://docs.docker.com/desktop/install/mac-install/)
  - [Install Docker Desktop for Windows](https://docs.docker.com/desktop/install/windows-install/)
  - [Install Docker Engine for Linux](https://docs.docker.com/engine/install/)

Verify your installation:
```bash
docker --version
docker compose version
```

## Quick Start

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd hookedonaneedle
   ```

2. **Configure environment variables**
   ```bash
   # Copy the example environment file
   cp .env.example .env

   # Edit .env if you want to customize credentials (optional)
   ```

3. **Start the environment**
   ```bash
   docker compose up -d
   ```

4. **Access WordPress**

   Open your browser and navigate to: **http://localhost:8080**

   Complete the WordPress installation wizard to set up your site.

## Common Commands

| Command | Description |
|---------|-------------|
| `docker compose up -d` | Start containers in detached mode |
| `docker compose down` | Stop containers (preserves data) |
| `docker compose down -v` | Stop containers and remove all data |
| `docker compose logs -f` | View container logs (follow mode) |
| `docker compose logs wordpress` | View WordPress container logs |
| `docker compose logs db` | View MySQL container logs |
| `docker compose exec wordpress bash` | Access WordPress container shell |
| `docker compose exec db mysql -uwordpress -pwordpress` | Access MySQL shell |
| `docker compose restart` | Restart all containers |

## Directory Structure

```
hookedonaneedle/
├── docker-compose.yml      # Container orchestration configuration
├── .env                    # Environment variables (not in version control)
├── .env.example            # Environment template for team members
├── .gitignore              # Git ignore rules
├── README.md               # This file
└── wp-content/
    ├── themes/             # Custom WordPress themes (bind mounted)
    │   └── .gitkeep
    └── plugins/            # Custom plugins and premium plugins (bind mounted)
        └── .gitkeep
```

### Volume Mappings

| Host Path | Container Path | Purpose |
|-----------|---------------|---------|
| `./wp-content/themes/` | `/var/www/html/wp-content/themes/` | Custom theme development |
| `./wp-content/plugins/` | `/var/www/html/wp-content/plugins/` | Custom plugin development |
| `mysql_data` (named volume) | `/var/lib/mysql/` | MySQL data persistence |

### Environment Variables

| Variable | Description | Default |
|----------|-------------|---------|
| `MYSQL_ROOT_PASSWORD` | MySQL root password | `rootpassword` |
| `MYSQL_DATABASE` | Database name | `wordpress` |
| `MYSQL_USER` | Database user | `wordpress` |
| `MYSQL_PASSWORD` | Database password | `wordpress` |
| `WORDPRESS_DB_HOST` | Database host | `db:3306` |
| `WORDPRESS_DB_USER` | WordPress DB user | `wordpress` |
| `WORDPRESS_DB_PASSWORD` | WordPress DB password | `wordpress` |
| `WORDPRESS_DB_NAME` | WordPress database name | `wordpress` |

## Development Workflow

### Custom Theme Development

1. Create your theme in `wp-content/themes/your-theme-name/`
2. Changes are immediately reflected in WordPress (no restart needed)
3. Activate the theme via WordPress Admin > Appearance > Themes

### Adding Plugins

1. Place plugins in `wp-content/plugins/`
2. For premium plugins (like ACF Pro), download and extract to the plugins directory
3. Activate via WordPress Admin > Plugins

### Database Operations

```bash
# Export database
docker compose exec db mysqldump -uwordpress -pwordpress wordpress > backup.sql

# Import database
docker compose exec -T db mysql -uwordpress -pwordpress wordpress < backup.sql
```

## CI/CD Integration

This environment is designed to support CI/CD deployment workflows:

- Only `wp-content/themes/` and `wp-content/plugins/` are version controlled
- WordPress core is managed by the container (not in repository)
- GitHub Actions can deploy theme/plugin changes to production servers
- The directory structure mirrors standard WordPress installations

## Troubleshooting

### Port 8080 Already in Use

**Error:** `Bind for 0.0.0.0:8080 failed: port is already allocated`

**Solution:**
1. Find the process using port 8080:
   ```bash
   lsof -i :8080
   ```
2. Either stop that process, or change the port in `docker-compose.yml`:
   ```yaml
   ports:
     - "8081:80"  # Use a different port
   ```

### Error Establishing Database Connection

**Error:** WordPress displays "Error establishing a database connection"

**Solutions:**
1. Ensure containers are running:
   ```bash
   docker compose ps
   ```
2. Check MySQL logs:
   ```bash
   docker compose logs db
   ```
3. Verify environment variables match between `.env` and services
4. Wait a few seconds for MySQL to fully initialize on first startup

### Permission Issues with wp-content

**Error:** Unable to create files/directories in themes or plugins

**Solution:**
```bash
# On macOS/Linux
chmod -R 755 wp-content/
```

### MySQL Keeps Restarting

**Error:** MySQL container continuously restarts

**Solution:**
```bash
# Remove corrupted data and start fresh
docker compose down -v
docker compose up -d
```

### Fresh Start (Reset Everything)

```bash
# Stop containers and remove all data
docker compose down -v

# Remove any local WordPress data that might have been created
rm -rf wp-content/uploads/

# Start fresh
docker compose up -d
```

## Support

For issues specific to this development environment, please open an issue in the repository. Contact: webmaster@hdsolutions360.com / https://johnnygipson.com