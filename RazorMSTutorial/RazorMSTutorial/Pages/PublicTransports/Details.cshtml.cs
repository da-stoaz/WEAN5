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
    public class DetailsModel : PageModel
    {
        private readonly RazorMSTutorial.Data.PublicTransportContext _context;

        public DetailsModel(RazorMSTutorial.Data.PublicTransportContext context)
        {
            _context = context;
        }

        public PublicTransport PublicTransport { get; set; } = default!;

        public IList<ServicePlan> AvailableServicePlans { get; set; } = new List<ServicePlan>();
        
        [BindProperty]
        public int SelectedServicePlanId { get; set; }

        public async Task<IActionResult> OnGetAsync(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var publictransport = await _context.PublicTransports
                                                .Include(pt => pt.ServicePlans) // Include ServicePlans
                                                .FirstOrDefaultAsync(m => m.Id == id);
            
            if (publictransport is null)
            {
                return NotFound();
            }

            PublicTransport = publictransport;

            AvailableServicePlans = await _context.ServicePlans
                                                  .Where(sp => sp.PublicTransportId == null) // Corrected: Filter by PublicTransportId == null
                                                  .ToListAsync();
            
            return Page();
        }
        

        
    }
}
