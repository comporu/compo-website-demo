FROM elasticsearch:5.6.8

RUN /usr/share/elasticsearch/bin/elasticsearch-plugin install analysis-icu
RUN /usr/share/elasticsearch/bin/elasticsearch-plugin install analysis-phonetic
RUN /usr/share/elasticsearch/bin/elasticsearch-plugin install https://dl.bintray.com/content/imotov/elasticsearch-plugins/org/elasticsearch/elasticsearch-analysis-morphology/5.6.8/elasticsearch-analysis-morphology-5.6.8.zip

WORKDIR /var/www/html
