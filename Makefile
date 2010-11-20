JS_LIB  := $(shell ls js/lib/*.js | sed "s/js\//--js js\//g" | xargs)
JS_BASE := $(shell ls js/*.js | sed "s/js\//--js js\//g" | xargs)

all: js/_prod/base.js js/_prod/lib.js css

js/_prod/base.js: js/*.js
	@echo '... compressing base.js'
	java -jar exec/compiler.jar $(JS_BASE) --js_output_file=js/_prod/base.js

js/_prod/lib.js: js/lib/*.js
	@echo '... compressing lib.js'
	java -jar exec/compiler.jar $(JS_LIB) --js_output_file=js/_prod/lib.js --warning_level QUIET

css: css/src
	compass compile css

