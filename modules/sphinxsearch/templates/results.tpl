{assign $maxPage=ceil($total/$limit)}
{jlocale 'sphinxsearch~search.results.searchString', array($string)}&nbsp;: 
{jlocale 'sphinxsearch~search.results.pageCount', array($page, $maxPage)} 
({jlocale 'sphinxsearch~search.results.totalCount', array($total)})

<ul class="searchResultsList">
{foreach $results as $infos}
    <li class="searchResultsItem">
        <a class="searchResultsTitle" href="{$infos['url']}">{$infos['title']}</a>
        <span class="searchResultsUrl">{$infos['url']}</span>
        <p class="searchResultsExtract">{$infos['extract']}</a>
    </li>
{/foreach}
</ul>

<div class="searchResultsNav">
    {if $page > 1}
    <a class="searchResultsNavPrev" href="{jurl $searchSel, array_merge($searchParams, array('page'=>$page-1))}">
        {@sphinxsearch~search.results.navPrev@}
    </a>
    {/if}

    {for $i=0; $i<$maxPage; $i++}
        {if $i+1 == $page}
            <span class="searchResultsNavCurr">
                {=$i+1}
            </span>
        {else}
            <a class="searchResultsNavLink" href="{jurl $searchSel, array_merge($searchParams, array('page'=>$i+1))}">
                {=$i+1}
            </a>
        {/if}
    {/for}

    {if $page < $total}
    <a class="searchResultsNavNext" href="{jurl $searchSel, array_merge($searchParams, array('page'=>$page+1))}">
        {@sphinxsearch~search.results.navNext@}
    </a>
    {/if}
</div>

