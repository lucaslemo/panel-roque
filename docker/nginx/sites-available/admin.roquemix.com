server {
    listen 80;
    listen [::]:80;
    server_name admin.roquemix.com;
    access_log /var/log/nginx/access.log combined;

    location / {
        proxy_pass http://phpmyadmin;
    }

    error_page 500 502 503 504 /50x.html;
    location = /50x.html {
        root /usr/share/nginx/html;
    }
}