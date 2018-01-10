---
---
# Website Theme Collection
A collection of responsive stand-alone website themes using current CSS Frameworks.  Some require PHP 7 to run.  Please see the [vertical-button-theme](https://github.com/emrickj/vertical-button-theme) repository to get sample website file(s).

| Name | Description | CSS Framework | |
| --- | --- | --- | --- |
{% for item in site.website_theme %}
| {{ item.name | prepend: "theme" }} | {{ item.desc }} | {{ item.cssf }} | <a class="action" title="Download" href="{{ item.name | prepend: "theme" }}.php"><span class="download"></span></a> {% if item.pwfn != nil %} <a class="action" title="Preview" href="{{ site.preview_path | append: item.name }}.php?u={{ item.pwfn }}" target="_blank"><span class="preview"></span></a> <a class="action" title="Preview Mobile" href="{{ site.mobile_emulator_path }}{{ site.preview_path | append: item.name }}.php?u={{ item.pwfn }}"
   target="_blank"><span class="phone"></span></a> {% endif %} 
{% endfor %}
