# Deploy JingJai to Vercel

This project uses the community `vercel-php` runtime for its PHP pages. The root `vercel.json` routes each existing `.php` URL to a small entrypoint in `api/`; those entrypoints include the original pages, so the source files remain in place. `app.js` and `images/` remain static assets.

## Deploy from GitHub

1. Push the project folder to a GitHub repository.
2. In Vercel, choose **Add New → Project** and import that repository.
3. Keep the project root at the repository root. Set Framework Preset to **Other** and leave Build Command empty.
4. Deploy. Vercel should use `vercel.json` to build the PHP functions and serve the static assets.

The PHP runtime is community-maintained, not a native Vercel runtime. The current login uses demo users and PHP sessions; do not use it as production authentication without moving session storage to a durable shared store and replacing the hard-coded demo credentials.
