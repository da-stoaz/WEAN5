using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.EntityFrameworkCore;
using PublicTransport.Data;
using PublicTransport.Entities;


namespace PublicTransport.Pages.PublicTransports
{
    public class IndexModel : PageModel
    {
        private readonly AppDbContext _context;

        [BindProperty(SupportsGet = true)] public string SearchString { get; set; } = string.Empty;

        public IndexModel(AppDbContext context)
        {
            _context = context;
        }

        public IList<PublicTransportE> PublicTransport { get; set; } = default!;

        public async Task OnGetAsync()
        {
            var pt = await _context.PublicTransports.ToListAsync();

            if (!string.IsNullOrEmpty(SearchString))
            {
                pt = pt.Where(t => t.TransportType.ToLower().Contains(SearchString.ToLower())).ToList();
            }

            PublicTransport = pt;
        }
    }
}