{{ Request::header('Content-Type : text/xml') }}

<?php echo '<?xml version="1.0" encoding="UTF-8"?>';?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @forelse ($categories as $category)
                <url>
                    <loc>{{ route('category', $category->slug) }}</loc>
                    <changefreq>monthly</changefreq>
                    <priority>1</priority>
                </url>
                {{-- @if ($category->children->count())
                    
                        @forelse ($category->children as $children)                        
                            
                                <url>
                                    <loc>{{ url('category', $children->slug) }}</loc>
                                    <changefreq>montly</changefreq>
                                    <priority>1</priority>
                                </url>
                        @empty
                            
                        @endforelse
                @endif  --}}
                
                @if ($category->products->count())
                    @forelse ($category->products as $product)
                        @if ($product->published)
                                <url>                                    
                                    <loc>{{ route('product', ['category' => $category->slug, 'product' => $product->slug]) }}</loc>
                                    <lastmod>{{ $product->updated_at->tz('GMT')->toAtomString() }}</lastmod>
                                    <changefreq>daily</changefreq>
                                    <priority>1</priority>
                                </url>
                        @endif                            
                    @empty
                        
                    @endforelse
                @endif
    @empty
        
    @endforelse
</urlset>