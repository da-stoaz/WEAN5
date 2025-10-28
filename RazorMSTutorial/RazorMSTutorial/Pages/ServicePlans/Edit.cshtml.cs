using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.AspNetCore.Mvc.Rendering;
using Microsoft.EntityFrameworkCore;
using RazorMSTutorial.Data;
using RazorMSTutorial.Models;

namespace RazorMSTutorial.Pages.ServicePlans
{
    public class EditModel : PageModel
    {
        private readonly RazorMSTutorial.Data.PublicTransportContext _context;

        public EditModel(RazorMSTutorial.Data.PublicTransportContext context)
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

            var serviceplan =  await _context.ServicePlans.FirstOrDefaultAsync(m => m.Id == id);
            if (serviceplan == null)
            {
                return NotFound();
            }
            ServicePlan = serviceplan;
            return Page();
        }

        // To protect from overposting attacks, enable the specific properties you want to bind to.
        // For more information, see https://aka.ms/RazorPagesCRUD.
        public async Task<IActionResult> OnPostAsync()
        {
            if (!ModelState.IsValid)
            {
                return Page();
            }

            _context.Attach(ServicePlan).State = EntityState.Modified;

            try
            {
                await _context.SaveChangesAsync();
            }
            catch (DbUpdateConcurrencyException)
            {
                if (!ServicePlanExists(ServicePlan.Id))
                {
                    return NotFound();
                }
                else
                {
                    throw;
                }
            }

            return RedirectToPage("./Index");
        }

        private bool ServicePlanExists(int id)
        {
            return _context.ServicePlans.Any(e => e.Id == id);
        }
    }
}
