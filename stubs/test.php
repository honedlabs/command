// The model

/**
 * {@inheritdoc}
 * 
 * @return \App\Builders\AddressBuilder<\App\Models\Address>
 */
public function newEloquentBuilder($query)
{
    return new {{ class }}($query);
}

/**
 * {@inheritdoc}
 * 
 * @return \App\Builders\AddressBuilder<\App\Models\Address>
 */
public static function query()
{
    // @phpstan-ignore-next-line
    return parent::query();   
}


// The class

/**
 * @template TModel of \App\Models\Address
 * 
 * @extends \Illuminate\Database\Eloquent\Builder<TModel>
 */
class {{ class }} extends Builder
{

}