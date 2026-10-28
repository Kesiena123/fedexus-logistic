# Deploying to Render

This app uses a Dockerfile and is configured for deployment on Render (Web Service with Docker runtime).

## Steps

1. Push this repo to GitHub.
2. Create a new Web Service on Render and connect your GitHub repo.
3. Set Runtime to `Docker`.
4. Render will use the included `Dockerfile` (exposes port 8080).
5. Add environment variables from `backend/.env.example` or your production config.
6. Deploy. On first run, `backend/start.sh` runs migrations and storage linking.

## Notes

- The app listens on port defined by `PORT` (defaults to 8080).
- Use a managed MySQL/Redis or Render add-ons as needed.
- Set `APP_KEY`, `APP_URL`, database credentials, and any mail/payment keys in Render env vars.
