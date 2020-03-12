@extends('stubs::php')

@section('class')
namespace {{ $stub->getNamespaceString() }};

/**
 * Class {{ $doc->getClassName() }}
 * @include('stubs::package', ['desc' => $source])
 *
@foreach ($doc->getAttributes() as $attribute)
 * @include('stubs::property', ['type' => $attribute->getType(), 'name' => $attribute->getName()])
@endforeach
 */
class {{ $doc->getClassName() }}
{
}
@endsection
