LogBundle
==========

## Instalação

Adicione o LogBundle em seu `composer.json`:

```js
{
    "require": {
        "zuni/log-bundle": "1.*@dev"
    }
}
```

Registre o bundle no AppKernel:

``` php
new Zuni\LogBundle\ZuniLogBundle(),
```

Para configurar crie um manager no doctrine para o bundle.
o nome do manager obrigatoriamente tem que ser `log` (por enquanto)
Vá em config (Arquivos importantes):

``` yaml
orm:
    auto_generate_proxy_classes: %kernel.debug%
    default_entity_manager:   default
    entity_managers:
        log:
            connection:       default
            mappings:
                ZuniLogBundle: ~
```

agora de um update schema no manager que você crio para o bundle
e pronto todas as entidades serão logadas. Caso você não queira que 
determinada entidade não seje logada, basta adicionar uma annotation na mesma:

``` php
...

/**
 * 
 * @Loggable\NotLoggable
 * @ORM\Entity
 * @ORM\Table(name="my_class")
 */
class MyClass
{

...

```
