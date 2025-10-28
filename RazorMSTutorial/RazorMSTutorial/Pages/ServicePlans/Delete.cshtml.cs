using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.EntityFrameworkCore;
using RazorMSTutorial.Data;
using RazorMSTutorial.Models;

namespace RazorMSTutorial.Pages.ServicePlans
{
    public class DeleteModel : PageModel
    {
        private readonly RazorMSTutorial.Data.PublicTransportContext _context;

        public DeleteModel(RazorMSTutorial.Data.PublicTransportContext context)
        {
            _context = context;
        }

        [BindProperty]
        public ServicePlan ServicePlan { get; set; } = default!;

        public async Task<IActionResult> OnGetAsync(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var serviceplan = await _context.ServicePlans.FirstOrDefaultAsync(m => m.Id == id);

            if (serviceplan is not null)
            {
                ServicePlan = serviceplan;

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

            var serviceplan = await _context.ServicePlans.FindAsync(id);
            if (serviceplan != null)
            {
                ServicePlan = serviceplan;
                _context.ServicePlans.Remove(ServicePlan);
                await _context.SaveChangesAsync();
            }

            return RedirectToPage("./Index");
        }
    }
}
