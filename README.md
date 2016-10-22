League Fractal Symfony Bundle
=============================

This bundle provides integration of [league/fractal](https://github.com/thephpleague/fractal) for Symfony. In addition it allows you to use [transformers as a services](#using-transformers-as-services).

## Getting Started

First of all you need to add dependency to composer.json:

```
composer require samj/fractal-bundle
```

Then register bundle in `app/AppKernel.php`:

```php
public function registerBundles()
{
    return [
        // ...
        new SamJ\FractalBundle\SamJFractalBundle(),
    ];
}
```

Now we can write and use fractal transformers:

## Using Transformers as Services

There are several cases when you need to pass some dependencies into transformer. The common one is [role/scope based results](https://github.com/thephpleague/fractal/issues/327) in transformers. For example you need to show `email` field only for administrators or owner of user profile:

```php
class UserTransformer extends TransformerAbstract
{
    private $authorizationCheker;
    
    public function __construct(AuthorizationChecker $authorizationCheker)
    {
        $this->authorizationCheker = $authorizationCheker;
    }
    
    public function transform(User $user)
    {
        $data = [
            'id' => $user->id(),
            'name' => $user->name(),
        ];
        
        if ($this->authorizationChecker->isGranted(UserVoter::SEE_EMAIL, $user)) {
            $data['email'] = $user->email();
        }
        
        return $data;
    }
}
```

Then you could just register this class as service, and pass service ID as transformer. This bundle then will try to get it from container:

```php
$resource = new Collection($users, 'app.transformer.user');
```

This works in includes as well:

```php
public function includeFriends(User $user)
{    
    return $this->collection($user->friends(), 'app.transformer.user');
}
```

You could see example of how to use transformers in [sample application](tests/Fixtures) which is used in test suites.
