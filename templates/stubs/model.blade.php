namespace Stubs\{{ $doc->getNamespace() }};

/**
 * Class {{ $doc->getClassName() }}
 * @package Stubs\{{ $doc->getNamespace() }}
 *
@foreach ($doc->getAttributes() as $attribute)
 * @property {{ $attribute->getType() }} {{ $attribute->getName() }}
@endforeach
 */
class {{ $doc->getClassName() }}
{
}
