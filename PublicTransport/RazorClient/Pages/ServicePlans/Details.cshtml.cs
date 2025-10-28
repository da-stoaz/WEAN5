using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using PublicTransport.Entities;
using System.Net.Http.Json; // Required for GetFromJsonAsync

namespace PublicTransport.Pages.ServicePlans
{
    public class DetailsModel : PageModel
    {
        private readonly IHttpClientFactory _httpClientFactory;

        public DetailsModel(IHttpClientFactory httpClientFactory)
        {
            _httpClientFactory = httpClientFactory;
        }

        public ServicePlan ServicePlan { get; set; } = default!;

        public async Task<IActionResult> OnGetAsync(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var client = _httpClientFactory.CreateClient("PublicTransportApi");
            var serviceplan = await client.GetFromJsonAsync<ServicePlan>($"api/ServicePlan/{id}");

            if (serviceplan is not null)
            {
                ServicePlan = serviceplan;

                return Page();
            }

            return NotFound();
        }
    }
}
