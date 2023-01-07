<script>
  import { page } from '$app/stores';
</script>

{@html JSON.stringify( $page )}
{$page.status}: {$page.error.message}