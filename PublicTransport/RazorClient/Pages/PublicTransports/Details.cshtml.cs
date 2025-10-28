using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.EntityFrameworkCore;
using PublicTransport.Data;
using PublicTransport.Entities;
using System.Collections.Generic; // Added for IList
using System.Linq; // Added for .Where() and .ToList()


namespace PublicTransport.Pages.PublicTransports
{
    public class DetailsModel : PageModel
    {
        
        private readonly IHttpClientFactory _httpClientFactory;

        public DetailsModel(IHttpClientFactory httpClientFactory)
        {
            _httpClientFactory = httpClientFactory;
        }

        public PublicTransportE PublicTransport { get; set; } = default!;

        // Changed from 'AllServicePlans' to 'AvailableServicePlans' and type to IList<ServicePlan>
        // to align with the original DbContext logic.
        public IList<ServicePlan> AvailableServicePlans { get; set; } = new List<ServicePlan>();
        

        public async Task<IActionResult> OnGetAsync(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }
            var httpClient = _httpClientFactory.CreateClient("PublicTransportApi"); 

         
            var publictransport = await (await httpClient.GetAsync("api/PublicTransport/" + id)
                ).Content.ReadFromJsonAsync<PublicTransportE>();
            
            // Fetch all service plans from the API endpoint.
            var allServicePlans = await (await httpClient.GetAsync("api/ServicePlan"))
                                        .Content.ReadFromJsonAsync<IEnumerable<ServicePlan>>();
            
            if (publictransport is not null)
            {
                PublicTransport = publictransport;

                // Filter the fetched service plans to include only those where PublicTransportId is null.
                // This mimics the filtering logic from your original DbContext implementation.
                if (allServicePlans != null)
                {
                    AvailableServicePlans = allServicePlans.Where(sp => sp.PublicTransportId == null).ToList(); 
                }

                return Page();
            }

            return NotFound();
        }
        
        public IActionResult OnPost()
        {
            return null;
        }
    }
}
