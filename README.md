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

By default we use the theme `EdsiTechSirTrevorBundle:Render:_blocks_theme.html.twig`.  
You can change it via Bundle config:

```yaml
# app/config/config.yml
edsi_tech_sir_trevor:
    edsi_tech_sir_trevor: 'EdsiTechSirTrevorBundle:Render:_blocks_theme.html.twig'
```

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


## Configuration

### Allowed blocks

By defaults not all SirTrevor blocks are enabled, you can modify it in bundle configuration:

```yaml
# app/config/config.yml
edsi_tech_sir_trevor:
    allowed_blocks:
        # below are blocks enabled by default
        # you can remove one of course!
        - Heading
        - Text
        - List
        - Quote
        # and I also want to add SirTrevor Image & Video blocks (watch out file upload are not handled at the moment)
        - Image
        - Video
        - Tweet
```

### Themes

When the content is rendered, we are using a `blocks_theme` to determine the HTML for each block *(in a manner pretty similar to Symfony2 Form theme)*. 
A default implementation is included; if you want to customize it, you can set your own Twig template in configuration.

All blocks are rendered within a `render_template` you can also override.

```yaml
# app/config/config.yml
edsi_tech_sir_trevor:
    blocks_theme: EdsiTechSirTrevorBundle:Render:_blocks_theme.html.twig
    render_template: EdsiTechSirTrevorBundle:Render:base.html.twig
```

### Adding an extra JS file

You can inject another JS file, loaded after included JS libraries but before the editor is initialized.
A common use case is to add some SirTrevor blocks.

```yaml
# app/config/config.yml
edsi_tech_sir_trevor:
    allowed_blocks:
        - Text
        - Heading
        - Custom # tip: do not forget to enable your custom block!
    extra_js_file: 'bundles/acmedemo/js/custom-block.js'
```


## Going further

### Getting Editor instance

You can retrieve the SirTrevor instance in JS by doing `SirTrevor.getInstance()`
