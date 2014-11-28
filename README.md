# SirTrevor Bundle *by EDSI-Tech Sarl*

Integration of [SirTrevor](https://github.com/madebymany/sir-trevor-js) JS library into a Symfony2 bundle.

SirTrevor editor works with "blocks", fragment of content of different types.
This bundle allow you to map those to Doctrine entities. 
Secondly, it provides a TwigExtension & templates to easily achieve a clean SirTrevor integration.

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/36f41ca4-4517-41c8-9c69-d0e3376732d6/big.png)](https://insight.sensiolabs.com/projects/36f41ca4-4517-41c8-9c69-d0e3376732d6)


## Installation

Using packing, require `edsi-tech/sir-trevor-bundle`
Then register it in `app/AppKernel.php`.


## Usage

### Model

You must extend `EdsiTech\SirTrevorBundle\Entity\AbstractBlock`.
`AbstractBlock` represent a block as SirTrevor knows it. It can be easily mapped to a Doctrine ORM entity, for this for already put some annotations.

### Rendering the editor

To render the editor, put in a Twig template:

```jinja
{{ cms_render(blocks) }}
```

You must pass to this template a `blocks` variable , containing a collection  of `AbstractBlock`.
Moreover, using a `is_editable` variable, you can decide whether to render a content editable with SirTrevor or just to render the blocks as plain old HTML.

### Saving blocks

Blocks will be re-send to your controller, via POST.
To handle those, you should use the provided `edsi_tech_sir_trevor.handler.block_handler` service. 
It will read the Request and return you an array of `EdsiTech\SirTrevorBundle\Model\EditedBlock`.


## Bonus

### Loading Bar

It includes a progress bar for editor loading.
Available using [Pace](http://github.hubspot.com/pace/).

### Flash messages

Request flash messages are displayed as nice messages powered by [HubSport Messenger](https://github.com/HubSpot/messenger)

Controller example:

```php
    public function renderAction()
    {
        $this->get('session')->getFlashBag()->add('success', 'Green success message');
        $this->get('session')->getFlashBag()->add('danger', 'Red danger message');
        $this->get('session')->getFlashBag()->add('info', 'Blue information message');

        return $this->render('myTwigTemplate', [
            'blocks'        => [] // an array of AbstractBlocks
            'is_editable'   => true
        ]);
    }
```

### "back" button

The bar on top added by this bundle can include a "back" button.
Just provide the URL it should point to in your controller:

```php
    public function renderAction()
    {
        return $this->render('myTwigTemplate', [
            'back_link'     => '/',
            'blocks'        => [] // an array of AbstractBlocks
            'is_editable'   => true
        ]);
    }
```

### Even more buttons

You can provide more buttons/HTML to add to the bar on top of the page via `save_bar_buttons`:

```php
    public function renderAction()
    {
        return $this->render('myTwigTemplate', [
            'save_bar_buttons' => '<a href="http://madebymany.github.io/sir-trevor-js/docs.html">Sir Trevor doc</a>',
            'blocks'        => [] // an array of AbstractBlocks
            'is_editable'   => true
        ]);
    }
```


## Full working example

The controller:

```php
    public function renderAction()
    {
        if ($request->isMethod('post')) {
            $data = $this->get('my_city_rendering.handler.block_handler')->handle($request);

            // do what you want!

            $this->get('session')->getFlashBag()->add('success', 'Content saved!');
        }
            
        return $this->render('myTwigTemplate', [
            'back_link'     => '/',
            'blocks'        => [] // an array of AbstractBlocks
            'is_editable'   => true,
            'save_bar_buttons` => '<a href="http://madebymany.github.io/sir-trevor-js/docs.html">Sir Trevor doc</a>',
        ]);
    }
```

The template:
```jinja
<html>
    <head>
        <title>SirTrevor example</title>
    </head>
    <body>
        <div>Some content that won't be editable by SirTrevor</div>
        <div>{{ cms_render(blocks) }}</div>
    </body>
</html>
```