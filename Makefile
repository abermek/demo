SF := bin/console

db:
	$(SF) d:d:d --force --if-exists &&\
	$(SF) d:d:c &&\
	$(SF) d:s:u --force &&\
	$(SF) d:f:l --no-interaction
