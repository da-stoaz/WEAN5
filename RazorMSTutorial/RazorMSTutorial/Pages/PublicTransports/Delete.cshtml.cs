using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.EntityFrameworkCore;
using RazorMSTutorial.Data;
using RazorMSTutorial.Models;

namespace RazorMSTutorial.Pages.PublicTransports
{
    public class DeleteModel : PageModel
    {
        private readonly RazorMSTutorial.Data.PublicTransportContext _context;

        public DeleteModel(RazorMSTutorial.Data.PublicTransportContext context)
        {
            _context = context;
        }

        [BindProperty]
        public PublicTransport PublicTransport { get; set; } = default!;

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
