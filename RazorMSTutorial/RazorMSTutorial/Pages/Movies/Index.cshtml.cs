using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.AspNetCore.Mvc.Rendering;
using Microsoft.EntityFrameworkCore;
using RazorMSTutorial.Models;
using RazorPagesMovie.Data;

namespace RazorMSTutorial.Pages.Movies
{
    public class IndexModel : PageModel
    {
        private readonly RazorPagesMovie.Data.RazorPagesMovieContext _context;

        public IndexModel(RazorPagesMovie.Data.RazorPagesMovieContext context)
        {
            _context = context;
        }

        public IList<Movie> Movie { get; set; } = default!;

        [BindProperty(SupportsGet = true)] public string? SearchString { get; set; }

        public SelectList? Genres { get; set; }

        [BindProperty(SupportsGet = true)] public string? MovieGenre { get; set; }

        public async Task OnGetAsync()
        {
            // <snippet_search_linqQuery>
            IQueryable<string> genreQuery = from m in _context.Movie
                orderby m.Genre
                select m.Genre;
            // </snippet_search_linqQuery>
            
            Console.WriteLine("Movie Genre: " + MovieGenre);


            var movies = from m in _context.Movie
                select m;
            if (!string.IsNullOrEmpty(SearchString))
            {
                movies = movies.Where(s => s.Title.ToLower().Contains(SearchString.ToLower()));
            }

            // <snippet_search_selectList>
            Genres = new SelectList(await genreQuery.Distinct().ToListAsync());
            // </snippet_search_selectList>
            Movie = await movies.Where(m => m.Genre == MovieGenre || MovieGenre == null).ToListAsync();
        }
    }
}