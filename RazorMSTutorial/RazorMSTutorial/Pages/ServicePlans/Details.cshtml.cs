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
    public class DetailsModel : PageModel
    {
        private readonly RazorMSTutorial.Data.PublicTransportContext _context;

        public DetailsModel(RazorMSTutorial.Data.PublicTransportContext context)
        {
            _context = context;
        }

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
    }
}
