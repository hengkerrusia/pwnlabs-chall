FROM node:18-alpine

WORKDIR /app

COPY src/package*.json ./

RUN npm install --production

COPY src/ ./

RUN addgroup -g 1001 -S nodejs && \
    adduser -S nodejs -u 1001 && \
    chown -R nodejs:nodejs /app

USER nodejs

EXPOSE 3000

CMD ["node", "server.js"]
