---
id: 644131f9-1ab3-4e5a-bb06-7c6170657621
blueprint: website
title: TekMountain.com
title_alias: Home
development-template:
  -
    uid: default
    path: /src/routes
    name: +page
    ext: svelte
    doctype:
      code: null
      mode: htmlmixed
    html:
      code: null
      mode: htmlmixed
    head:
      code: null
      mode: htmlmixed
    title:
      code: '<title>Home Page | [websitecontroller.template.title]</title>'
      mode: htmlmixed
    link:
      code: null
      mode: htmlmixed
    meta:
      code: null
      mode: htmlmixed
    style:
      code: |-
        <style>
        	/* Style */
        </style>
      mode: htmlmixed
    script:
      code: |-
        <script>
        	/* Script */
        </script>
      mode: htmlmixed
    body:
      code: |-
        <svelte:head><!-- Auto Inject Title, Link, & Meta from Above -->
        </svelte:head>
        Hello Parent Page!
      mode: htmlmixed
    type: item
    enabled: true
replicate:
  - 'null'
target: development
updated_by: 3fcfe9a1-6362-444c-8d55-030541dd2f8d
updated_at: 1672956275
---
