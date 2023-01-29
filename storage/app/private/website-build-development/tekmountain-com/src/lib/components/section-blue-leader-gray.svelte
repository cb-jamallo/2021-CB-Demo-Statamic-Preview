<!-- @html{JSON.stringify( $$slots )} -->
<section class='section-blue grid grid-stacked {$$props.sectionClass}' {...$$restProps}>
    <div class='place-self-start-center'>
        <div class='section-leader-gray place-self-center-center text-align-center'>
            {#if $$slots['leader-h2']}
                <h2 class='h2'><slot name="leader-h2"></slot></h2>
            {/if}
            {#if $$slots['leader-p-1']}
                <p class='p'><slot name="leader-p-1"></slot></p>
            {/if}
            {#if $$slots['leader-p-2']}
                <p class='p'><slot name="leader-p-2"></slot></p>
            {/if}
            {#if $$slots['leader-p-3']}
                <p class='p'><slot name="leader-p-3"></slot></p>
            {/if}
        </div>   
        {#if $$slots['default']}
            <slot>aasas</slot>
        {/if}
    </div>

    {#if $$slots['background-3']}
        <div>
            <slot name="background-3"></slot>
        </div>
    {/if}

    {#if $$slots['background-2']}
        <div>
            <slot name="background-2"></slot>
        </div>
    {/if}

    {#if $$slots['background-1']}
        <div>
            <slot name="background-1"></slot>
        </div>
    {/if}

</section>

<style global class='postcss'></style>