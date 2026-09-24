{
  "functions": {
    "api/index.php": {
      "runtime": "vercel-php@0.9.0",
      "includeFiles": "jobsheet0[78]/**"
    }
  },
  "routes": [
    { "src": "/(jobsheet0[78](?:/.*)?)", "dest": "/api/index.php" },
    { "handle": "filesystem" }
  ]
}