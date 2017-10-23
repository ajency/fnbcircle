@foreach($ldJsons as $ldJson)
<script type="application/ld+json">
{!! json_encode($ldJson, JSON_UNESCAPED_SLASHES) !!}
</script>
@endforeach
