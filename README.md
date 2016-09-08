# Symfony Viewable Bundle

## Installation: 

##### Register bundle
register bundle in AppKernel.php

```
new Etudor\ViewableBundle\EtudorViewableBundle(),
```

## Usage:

##### Inside twig: ``` this ```
- will try to render the ``` Post/base.html.twig ```
```
{{ post|view }}
```

- will try render ``` Post/custom_view.html.twig ```
```
{{ post|view('custom_view') }}
```

- will try render ``` Post/custom_view.html.twig ``` with params
```
{{ post|view('custom_view', {'param1': param1, 'param2': param2, 'iAmParam': 'testParamString'} }}
```

#### Inside twig with collection or array: ``` many ```
when the variable you are trying to render is a array of objects or an instance of Collection.

- will render ``` Post/Listing/base.html.twig ```
```
{{ posts|view }}
```

- will render ``` Post/Listing/custom_view.html.twig ```
```
{{ posts|view('custom_view') }}
```

- will try render ``` Post/Listing/custom_view.html.twig ``` with params
```
{{ posts|view('custom_view', {'param1': param1, 'param2': param2, 'iAmParam': 'testParamString'} }}
```

### Access object inside view
* if object access with: ``` this ```
```
Post/base.html.twig
<h1>{{ this.title }}</h1>
```

* if array or collection access with: ``` many ```
```
Post/Listing/base.html.twig
{% for post in many %}
    <div clsas="post">
        {{ post|view }}
    </div>
{% endfor %}
```


### Roadmap:
- add accesors for object. Add posibility to register custom accesors for objects.
For example: you have a Post entity. For the Post with id: 50 you want a custom view. 
Register an accesor with $post->getId() and for every view rendered for an Post object the extension will try to find the view with name _50.html.twig

```
{{ post|view }} -> will render Post/base_50.html.twig if it exists (will fallback to Post/base.html.twig)
```

```
{{ post|view('custom_view') }} -> will render Post/custom_view_50.html.twig if it exists (will fallback to Post/custom_view.html.twig)
```

Let's say for example you want different view for posts from category: "Games"
- register an accesor for $post->getCategory->getSlug()
```
{{ post|view }} -> will render Post/base_games.html.twig
```

```
{{ post|view('custom_view') }} -> will render Post/custom_view_games.html.twig
```

- add posibility to register accesors with priority
- add posibility to generate mixed accesors: 
``` $post->getId() % 2 != 0 ? 'odd' : 'even'; ```
and ``` $post->getCategory()->getSlug()  ``` will render ``` Post/base_games_odd.html.twig ``` if the post id is odd
and ``` Post/base_games_even.html.twig ``` if post id is even
