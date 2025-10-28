using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.AspNetCore.Mvc.Rendering;
using RazorMSTutorial.Data;
using RazorMSTutorial.Models;

namespace RazorMSTutorial.Pages.ServicePlans
{
    public class CreateModel : PageModel
    {
        private readonly RazorMSTutorial.Data.PublicTransportContext _context;

        public CreateModel(RazorMSTutorial.Data.PublicTransportContext context)
        {
            _context = context;
        }

        public IActionResult OnGet()
        {
            return Page();
        }

        [BindProperty]
        public ServicePlan ServicePlan { get; set; } = default!;

        // For more information, see https://aka.ms/RazorPagesCRUD.
        public async Task<IActionResult> OnPostAsync()
        {
            if (!ModelState.IsValid)
            {
                return Page();
            }

            _context.ServicePlans.Add(ServicePlan);
            await _context.SaveChangesAsync();

            return RedirectToPage("./Index");
        }
    }
}
