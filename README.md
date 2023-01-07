# Statamic Management TOC

  

-  **Installation, License, & Activation**

1.  [Create Site(s)](https://statamic.dev/licensing#sites)

2.  [Activate License](https://statamic.dev/licensing#production)

-  [Licensing Rules](https://statamic.dev/licensing#one-license-per-site)

-  [Public Domains](https://statamic.dev/licensing#public-domains)

3.  [Activate 'Pro' Mode](https://statamic.dev/licensing#solo-vs-pro)

4.  [Activate API](https://statamic.dev/rest-api#enable-the-api)

  

-  **Users, Groups, & Permissions**

-  [Adding Users Manually](https://statamic.dev/tips/creating-users-by-hand)

-  [Create Super User](https://statamic.dev/tips/creating-users-by-hand#walkthrough-creating-a-new-super-user)

-  [Assigning Non-Super User Roles](https://statamic.dev/tips/creating-users-by-hand#assigning-nonsuper-roles)

  

-  **Debugging**

-  [Debug Bar](https://statamic.dev/debugging#how-to-enable-the-debug-bar)

-  [Debug Bar Enable/Disable](https://statamic.dev/debugging#how-to-enable-the-debug-bar)

  
  

# Shortcodes

  

### Schema

The schema shortcodes are reserved template strings compiled during the publishing process. They are comprised a Website Collection's Entry data as follows:

  

-  **[ schema.website... ]** Contains the data input into a Website Entry

-  **[ schema.controller... ]** Contains the data input into the Website Controller Entry that contains the same title value

-  **[ schema.compiled... ]** Contains the data input that is compiled between the Website Entry, it's Website Controller Entry.

  

**Shortcode compiling process rules:**
- All required fields must contain a value
- Only cross-reference parallel fields shortcode
	- Parallel fields both cross-referencing each others' shortcode will result in a failed compile

**Shortcode compiling process conditions:**

Cross-referencing can only be one-way. Two-way cross-referencing will cause the publishing process to fail.
	- See example: Do Not Cross-Reference Two-way
- A required value being empty in a matching field will cause the publishing process to fail.
- An un-required empty value in a matching field will be discarded and default to the value its parallel.
	- See example: Cross-Reference when one value is empty:
- Matching fields that both cross-referencing the other will cause the publishing process to fail as it can only be compiled in one direction.

**Do Not Two-way Cross-Reference**

```html
Website Metadata Base cross-referencing the Website Controller Metadata Base
[ schema.controller.metadata.base] will equal a string value of '[ schema.controller.metadata.base]'

Website Controller Metadata Base cross-referencing the Website Metadata Base
[ schema.controller.metadata.base] will equal a string value of '[ schema.website.metadata.base]'

Compiled Metadata Base will result in:
[ schema.controller.metadata.base ] will equal null
```

**One-Way Cross-Reference Emtpy Value:**
```html

Website Metadata Base with no value results in:
[ schema.website.metadata.base] will equal a string value of  '';

Website Controller Metadata Base with a value of 'domain.com' results in:
[ schema.controller.metadata.base ] will equal a string value of 'domain.com'

Compiled Metadata Base result:
[ schema.controller.metadata.base ] will equal a string value of 'domain.com'
```



### Metadata

**Base**

HTML Url `<base>` tag value

  

Compiled: True

- Website

- Website Controller

  

Shortcodes:

- Website: `[ schema.website.metatadata.base ]`

- Website Controller: `[ schema.controller.metatadata.base ]`

- Compiled: `[ schema.compiled.metatadata.base ]`

  
  

**Metadata Canonical**

Shortcode: `[ schema.controller.metatadata.canonical ]`

HTML SEO Url `<meta>` tag value

  

**[ schema.controller.metatadata.title ]**

HTML SEO `<title>` tag value

  

**[ schema.controller.metatadata.description ]**

HTML SEO `<meta name='description content='{ schema.controller.metatadata.title }'>` tag value