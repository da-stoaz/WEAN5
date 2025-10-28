using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.EntityFrameworkCore;
using PublicTransport.Data;
using PublicTransport.Entities;

namespace PublicTransport.Pages.PublicTransports
{
    public class DetailsModel : PageModel
    {
        private readonly AppDbContext _context;

        public DetailsModel(AppDbContext context)
        {
            _context = context;
        }

        public PublicTransportE PublicTransport { get; set; } = default!;

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
