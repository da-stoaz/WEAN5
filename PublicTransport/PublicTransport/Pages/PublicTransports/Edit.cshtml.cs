using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.AspNetCore.Mvc.Rendering;
using Microsoft.EntityFrameworkCore;
using PublicTransport.Data;
using PublicTransport.Entities;


namespace PublicTransport.Pages.PublicTransports
{
    public class EditModel : PageModel
    {
        private readonly AppDbContext _context;

        public EditModel(AppDbContext context)
        {
            _context = context;
        }

        [BindProperty]
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
                .FirstOrDefaultAsync(m => m.Id == id);            if (publictransport == null)
            {
                return NotFound();
            }
            PublicTransport = publictransport;
            AvailableServicePlans = await _context.ServicePlans
                .Where(sp => sp.PublicTransportId == null) // Corrected: Filter by PublicTransportId == null
                .ToListAsync();
            return Page();
        }

        public async Task<IActionResult> OnPostAsync()
        {
            if (!ModelState.IsValid)
            {
                return Page();
            }

            _context.Attach(PublicTransport).State = EntityState.Modified;

            try
            {
                await _context.SaveChangesAsync();
            }
            catch (DbUpdateConcurrencyException)
            {
                if (!PublicTransportExists(PublicTransport.Id))
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

        private bool PublicTransportExists(int id)
        {
            return _context.PublicTransports.Any(e => e.Id == id);
        }
        
         public async Task<IActionResult> OnPostRemoveServicePlanAsync(int publicTransportId, int servicePlanId)
        {
            var publicTransport = await _context.PublicTransports
                                                .Include(pt => pt.ServicePlans)
                                                .FirstOrDefaultAsync(pt => pt.Id == publicTransportId);

            if (publicTransport == null)
            {
                return NotFound();
            }

            ServicePlan? servicePlanToRemove = publicTransport.ServicePlans.FirstOrDefault(sp => sp.Id == servicePlanId);

            if (servicePlanToRemove != null)
            {
                servicePlanToRemove.PublicTransportId = null; 
                await _context.SaveChangesAsync();
            }

            return RedirectToPage(new { id = publicTransportId });
        }

        public async Task<IActionResult> OnPostAddServicePlanAsync(int publicTransportId)
        {
            if (SelectedServicePlanId == 0) 
            {
                await OnGetAsync(publicTransportId);
                ModelState.AddModelError(string.Empty, "Please select a service plan to add.");
                return Page();
            }

            var publicTransport = await _context.PublicTransports
                                                .Include(pt => pt.ServicePlans)
                                                .FirstOrDefaultAsync(pt => pt.Id == publicTransportId);

            if (publicTransport == null)
            {
                return NotFound();
            }

            var servicePlanToAdd = await _context.ServicePlans.FindAsync(SelectedServicePlanId);

            if (servicePlanToAdd != null && servicePlanToAdd.PublicTransportId == null) // Corrected: Check PublicTransportId == null
            {
                servicePlanToAdd.PublicTransportId = publicTransport.Id; // Corrected: Assign PublicTransportId
                await _context.SaveChangesAsync();
            } else {
                await OnGetAsync(publicTransportId);
                ModelState.AddModelError(string.Empty, "Selected service plan is invalid or already assigned.");
                return Page();
            }

            return RedirectToPage(new { id = publicTransportId });
        }
    }
}
