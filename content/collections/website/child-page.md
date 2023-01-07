---
id: 6134a0ca-717e-4251-8d41-d93319d3d010
blueprint: website
title: 'Child Page'
page:
  -
    uid: Default
    as: html
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
      code: null
      mode: htmlmixed
    body:
      code: Hello!!
      mode: htmlmixed
    type: item
    enabled: false
parent: 644131f9-1ab3-4e5a-bb06-7c6170657621
target: development
replicate:
  - page
development-template:
  -
    uid: default
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
      code: '<title>Child Page | [websitecontroller.template.title]</title>'
      mode: htmlmixed
    link:
      code: null
      mode: htmlmixed
    meta:
      code: null
      mode: htmlmixed
    style:
      code: null
      mode: htmlmixed
    script:
      code: null
      mode: htmlmixed
    body:
      code: 'Hello Child Page!'
      mode: htmlmixed
    type: item
    enabled: true
    path: /src/routes
development-meta:
  -
    uid: description
    type: item
    enabled: true
    content: '<meta name=''description'' content=''Child Page...'' />'
updated_by: 3fcfe9a1-6362-444c-8d55-030541dd2f8d
updated_at: 1673070412
---
