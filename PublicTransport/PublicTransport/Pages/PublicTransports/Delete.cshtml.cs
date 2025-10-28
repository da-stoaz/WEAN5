using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.EntityFrameworkCore;
using PublicTransport.Data;
using PublicTransport.Entities;


namespace PublicTransport.Pages.PublicTransports
{
    public class DeleteModel : PageModel
    {
        private readonly AppDbContext _context;

        public DeleteModel(AppDbContext context)
        {
            _context = context;
        }

        [BindProperty]
        public PublicTransportE PublicTransport { get; set; } = default!;

        public async Task<IActionResult> OnGetAsync(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var publictransport = await _context.PublicTransports.FirstOrDefaultAsync(m => m.Id == id);

            if (publictransport is not null)
            {
                PublicTransport = publictransport;

                return Page();
            }

            return NotFound();
        }

        public async Task<IActionResult> OnPostAsync(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var publictransport = await _context.PublicTransports.FindAsync(id);
            if (publictransport != null)
            {
                PublicTransport = publictransport;
                _context.PublicTransports.Remove(PublicTransport);
                await _context.SaveChangesAsync();
            }

            return RedirectToPage("./Index");
        }
    }
}
