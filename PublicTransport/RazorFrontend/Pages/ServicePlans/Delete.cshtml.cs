using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.EntityFrameworkCore;
using PublicTransport.Data;
using PublicTransport.Entities;

namespace RazorFrontend.Pages.ServicePlans
{
    public class DeleteModel : PageModel
    {
        private readonly AppDbContext _context;
        
        private readonly IHttpClientFactory _httpClientFactory;

        public DeleteModel(AppDbContext context, IHttpClientFactory httpClientFactory)
        {
            _context = context;
            _httpClientFactory = httpClientFactory;
        }

        [BindProperty]
        public ServicePlan ServicePlan { get; set; } = default!;

        public async Task<IActionResult> OnGetAsync(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }
            var client = _httpClientFactory.CreateClient("PublicTransportApi");
            var serviceplan = await client.GetFromJsonAsync<ServicePlan>("api/ServicePlan/" + id);

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

            var client = _httpClientFactory.CreateClient("PublicTransportApi");
            var response = await client.DeleteAsync($"api/ServicePlan/{id}");

            if (!response.IsSuccessStatusCode)
            {
                return NotFound();
            }
            
            return RedirectToPage("./Index");
        }
    }
}
