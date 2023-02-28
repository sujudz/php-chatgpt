const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  transpileDependencies: true,
  devServer: {
      open: true,
      // host: 'localhost',
      port: 8080,
      https: false,
      proxy: {
          '/api': {
	          target: 'http://www.gptapp-dev.com',
	          ws: true,
	          changOrigin: true,
	          pathRewrite: {
	            '^/api': '/'
	         }
          },
          '/login': {
	          target: 'http://www.gptapp-dev.com',
	          ws: true,
	          changOrigin: true,
	          pathRewrite: {
	            '^/login': '/login'
	          }
          }
      }
   }
})
