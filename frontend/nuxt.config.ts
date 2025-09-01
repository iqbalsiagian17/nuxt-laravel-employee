export default defineNuxtConfig({
  css: ['bootstrap/dist/css/bootstrap.min.css'],
  vite: {
    define: {
      'process.env.DEBUG': false,
    },
  },
  app: {
    head: {
      script: [
        { src: "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" }
      ]
    }
  }
})
